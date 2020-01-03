<?php
class Character {
    /*  
        Base class for all characters taking part in the game,
        both player driven and non-player ones.
        Defines all mandatory atributes and methods required
        for interaction with the game world and other characters
    */
    // The name of the character
    private $name;
    // Current health of the character 
    private $currentHP;
    // Basic 4 stats common for all charaters ingame
    private $stats = Array(
        'lvl' => 0,
        'str' => 0,
        'agi' => 0,
        'vit' => 0,
        'int' => 0,
    );
    // Armor class based on character specyfic
    private $AC;
    // Common constructor 
    public function __construct() {
        $this->name = "Random character " + rand(1,1000);
        $this->stats['lvl'] = rand(1,4);
        $this->stats['str'] = rand(1,20);
        $this->stats['agi'] = rand(1,20);
        $this->stats['vit'] = rand(1,20);
        $this->stats['int'] = rand(1,20);
        $this->currentHP = $this->MaxHP();
        $this->AC = rand(0,20);
    }
    // Common methods
    public function Name() {
        return $this->name; // return character name
    }
    public function HP() {
        return $this->currentHP; // return current HP
    }
    public function Stats() {
        return $this->stats; // return all stats (as Array)
    }
    public function AbilityModifier() {
        return floor(($this->Stats()['str'] - 10) / 2); //for strength based attack (attribute - 10) / 2
    }
    public function ExpertiseBonus() {
        return floor($this->Stats()['lvl'] / 2); //bonus for lvl diference (lvl / 2)
    }
    public function AttackRoll() {
        // calcuate the attack roll a.k.a. chance to hit
        // derived from D&D with minor simplification
        $roll = rand(1,20); // roll a D20 dice
        if($roll = 1) return 0; // critical miss
        if($roll = 20) return 100; // critical hit
        $roll += $this->AbilityModifier(); // add bonus from strength (attribute - 10) / 2
        $roll += $this->ExpertiseBonus(); // add expertise bonus 
        return $roll;
    }
    public function DamageRoll() {
        $roll = rand(1,20); // roll D20 base damage
        $roll += $this->AbilityModifier(); // add bonus from strength (attribute - 10) / 2
        return $roll;
    }
    public function ArmorClass() {
        return $this->AC;
    }
    public function MaxHP() {
        $HP = 0;
        for($i = 1 ; $i <= $this->stats['lvl'] ; $i++) {
            // for each lvl roll d8
            $HP += rand(1,8);
            // and add vitality
            $HP += $this->stats['vit'];
        }
        return $HP;
    }
}
?>