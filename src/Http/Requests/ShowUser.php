<?php

namespace Acacha\Events\Http\Requests;

use Acacha\Events\Http\Requests\Traits\ChecksPermissions;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShowUser
 *
 * @package App\Http\Requests
 */
class ShowUser extends FormRequest
{
    use ChecksPermissions;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->hasPermissionTo('show-user')) return true;
        if ($this->owns('user','id')) return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
