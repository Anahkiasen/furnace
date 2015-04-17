<?php
namespace Furnace\Http\Requests;

use Auth;
use Furnace\Entities\Models\Rating;

class UpsertRating extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @type Rating $rating */
        $rating = $this->route('ratings');
        $user   = Auth::user();

        return $user && $rating->user_id == $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'presilence'        => 'required|boolean',
            'normalized_volume' => 'required|boolean',
            'playable'          => 'required|boolean',
            'tone'              => 'required|between:0,3',
            'audio'             => 'required|between:0,3',
            'tab'               => 'required|between:0,3',
        ];
    }
}
