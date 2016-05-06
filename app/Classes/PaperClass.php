<?php
/**
 * Created by PhpStorm.
 * User: Tihomir
 * Date: 25.3.2016 г.
 * Time: 21:46
 */

namespace App\Classes;

use App\Paper;
use Illuminate\Support\Facades\File;
use League\Flysystem\Exception;

class PaperClass
{
    private $paper;
    private $files = [ 'paper' => 'paper', 'paper_name' => '', 'invoice' => 'payment_source', 'invoice_name' => ''];
    static private $path;

    public function __construct()
    {
        self::$path = 'papers/' . request()->segment(2) . '/';
    }

    public function setUrl($url)
    {
        self::$path = 'papers/' . $url . '/';
    }

    public function setPaper(Paper $paper)
    {
        $this->paper = $paper;
    }

    /*
     * @param name - filename
     * $key - paper or
     */
    public function upload($name = null)
    {
        if (request()->file($this->files['paper'])) {
            request()->file($this->files['paper'])->move(self::$path, $name ? : $this->buildFileName());
        }

        if (request()->file($this->files['invoice'])) {
            request()->file($this->files['invoice'])->move(self::$path, $name ? : $this->buildInvoiceName());
        }
    }

    /*
     * keep file name + add user first name last name first letters and user paper number
     * @param key - paper,payment_source
     * @param invoice - boolean
     */
    public function buildFileName($invoice = false)
    {
        $key = $invoice ? 'invoice' : 'paper';
        if ($this->files[$key . '_name']) { #if already build
            return $this->files[$key . '_name'];
        }

        if (!request()->file($this->files[$key])) {
            return '';
        }

        $ext = request()->file($this->files[$key])->getClientOriginalExtension();
        $name = request()->file($this->files[$key])->getClientOriginalName();
        $name = str_replace('.' . $ext, '', $name);
        #check if name is bigger then 90 chars and cut + remove ... from string
        $name = str_limit($name, 90);
        if (substr($name, -1) == '.') {
            $name = substr($name, 0, -3);
        }
        $userName = explode(' ', auth()->user()->name);
        $name .= '_' . $userName[0][0] . $userName[1][0]; #get user letters
        if ($invoice) {
            $name .= 'I'; #add i before number
        }
        $name .= rand(1, 999);
        $name .= '.' . $ext; #add extension
        if (File::exists(self::$path . $name)) {
            $name = $this->buildFileName($invoice);
        }
        $this->files[$key . '_name'] = $name;

        return $name;
    }

    public function buildInvoiceName()
    {
        return $this->buildFileName(true);
    }

    public function delete()
    {
        if ($this->paper->status_id == 1 || isAdminPanel()) {
            try {
                $this->paper->delete();
            } catch(Exception $e) {
                return false;
            }
            $this->deleteFile();
            $this->deleteInvoice();
            return true;
        }
        return false;
    }

    public function deleteFile()
    {
        File::delete(self::$path . $this->paper->source);
    }

    public function deleteInvoice()
    {
        File::delete(self::$path . $this->paper->payment_source);
    }
}