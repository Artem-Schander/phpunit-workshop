<?php
use PHPUnit\Framework\TestCase;
use App\Slugify;

class SlugifyTest extends TestCase
{
    /** @test */
    public function creating_a_slug_from_a_string()
    {
        $result = Slugify::make('Zwölf große Boxkämpfer jagen Viktor quer über den Sylter Deich');
        $this->assertEquals('zwoelf-grosse-boxkaempfer-jagen-viktor-quer-ueber-den-sylter-deich', $result);
    }

    /** @test */
    public function creating_a_slug_with_multiple_spaces()
    {
        $slug = Slugify::make('Ein  schlecht formatierter Text');
        $this->assertNotEquals('ein--schlecht-formatierter-text', $slug);
        $this->assertEquals('ein-schlecht-formatierter-text', $slug);
    }

    /** @test */
    public function creating_a_slug_with_different_unsupported_signs()
    {
        $slug = Slugify::make('Test das: ,.-+#`\/`°!"§$%&=/()*"! Und noch ein paar Zahlen: 1234567890');
        $this->assertEquals('test-das-und-ein-paar-zahlen-1234567890', $slug);
    }
}
