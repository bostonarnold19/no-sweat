<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;
use Throwable;
use Illuminate\Http\Request;

class ModuleGeneratorException extends Exception
{
    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function render(Request $request): RedirectResponse
    {
        return redirect()->back()->with('error', $this->message);
    }
}
