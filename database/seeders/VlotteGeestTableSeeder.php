<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class VlotteGeestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vlotte_geest')->insert([
            'name' => 'vlotteGeest',
            'amountOfCards' => 60,
            'description' =>  "Het huisspook heeft in de kelder van de burcht een oud fotoapparaat gevonden. Daarbij heeft hij alles op de gevoelige plaat gezet wat hij bij het rondspoken graag laat verdwijnen... en ook zichzelf natuurlijk. Helaas maakt de betoverde camera veel foto's in de verkeerde kleur. Soms is de groene fles wit, dan weer blauw. Als hij de foto's bekijkt, raakt hij zo in de war dat hij niet meer weet wat hij moet wegtoveren. Kun jij hem helpen en het juiste voorwerp noemen of zelfs voor hem laten verdwijnen? Elke ronde wordt een kaart omgedraaid. De spelers moeten nu zo snel mogelijk het gezochte voorwerp pakken of roepen. Wie dat het snelste doet, krijgt de kaart. Wie wint de meeste kaarten? Vijf voorwerpen staan in een kring op tafel, zodat iedereen er goed bij kan. Een speler draait de bovenste kaart om. Iedere speler probeert nu zo snel mogelijk het voorwerp van tafel te grijpen dat op deze kaart in de juiste kleur is afgebeeld. Als er op de kaart geen voorwerp in de juiste kleur is afgebeeld, moeten de spelers het voorwerp grijpen dat niet op de kaart is afgebeeld en waarvan de kleur ook niet op de kaart te zien is. Wie als eerste het juiste voorwerp heeft gegrepen, legt als beloning de omgedraaide kaart voor zich op tafel en draait daarna de volgende kaart van de gedekte stapel om.",
            
        ]);
    }
}
