<?php

namespace App\Http\DTO;

use Illuminate\Http\Request;

class Group
{
    public function __construct(
        public string $name,
    ){}

    public static function GroupValidatedFromRequest(Request $request): Group
    {
        $validated = $request->validate(['name' => ['required','string','max:255']]);
        return new self(
            name: $validated['name']
        );
    }
}
