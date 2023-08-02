<?php

use App\Lang\Language;

it('can transfrom language keyword to matching label', function () {
    expect(Language::from('en')->label())->toBe("English");
    expect(Language::from('mm')->label())->toBe("Myanmar");
});
