<?php
namespace Furnace\Http\Requests;

use Auth;

class UpsertTrack extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'track_id'    => 'required_without:ignition_id|exists:tracks,id',
            'ignition_id' => 'required_without:track_id',
        ];
    }
}
