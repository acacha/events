<?php

namespace Acacha\Events\Http\Requests;

use Acacha\Events\Http\Requests\Traits\ChecksPermissions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class StoreEvent
 *
 * @package App\Http\Requests
 */
class StoreEvent extends FormRequest
{
    use ChecksPermissions;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->hasPermissionTo('store-event')) return true;
        if (Auth::user()->id === $this->user_id) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'user_id' => 'required'
        ];
    }
}
