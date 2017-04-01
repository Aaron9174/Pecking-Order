using System.Collections;
using System.Collections.Generic;
using UnityEngine.UI;
using UnityEngine;

public class oneCreatureManager : MonoBehaviour {

    //get a card and preview for the creature
    public cardAsset card;
    public OneCardManager PreviewManager;

    //text components, only attack
    [Header("Text Component References")]
    public Text AttackText;

    //image components
    [Header("Image References")]
    public Image creatureImage;
    public Image creatureGlow;

    //in awake, run readfromcardasset
    private void Awake()
    {
        if (card != null)
            ReadFromCardAsset();
    }

    //assign all visual aspects of the attached card to the actual card and its preview
    public void ReadFromCardAsset()
    {
        creatureImage.sprite = card.CardImage;
        AttackText.text = card.Attack.ToString();

        if (PreviewManager != null)
        {
            PreviewManager.card = card;
            PreviewManager.ReadCardFromAsset();
        }   
    }

    //can we attack or nah?
    private bool canAttack;

    //will show whether a creature can attack via a glow and boolean
    public bool CanAttack
    {
        get
        {
            return canAttack;
        }

        set
        {
            canAttack = value;

            if (creatureGlow != null)
                creatureGlow.enabled = value;
        }
    }

    public void takeDamage(int amount, int attackAfter)
    {
        if(amount > 0)
        {
            // TODO DamageEffect.CreateDamageEffect(transform.position, amount);
            AttackText.text = attackAfter.ToString();
        }
    }
}
