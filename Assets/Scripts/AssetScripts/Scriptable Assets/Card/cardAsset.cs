using UnityEngine;

public enum TargetingOptions
{
    NoTarget,
    AllCreatures,
    EnemyCreatures,
    MyCreatures,
    AllCharacters,
    EnemyCharacters,
    MyCharacters
}

public class cardAsset : ScriptableObject
{ 
    [Header("General Info")]
    public characterAsset characterAsset;
    public Sprite typeImage;
    public bool isCreature;
    public bool isSpell;

    [TextArea(3, 4)]
    public string Description;
    public Sprite CardImage;
    public int ManaCost;

    [Header("Creature Info")]
    public int Attack;
    public int AttacksForOneTurn = 1;
    public bool Taunt;
    public bool Charge;
    public string CreatureScriptName;
    public int specialCreatureAmount;
    public int level;

    [Header("Spell Info")]
    public string SpellScriptName;
    public int specialSpellAmount;
    public TargetingOptions Targets;


}