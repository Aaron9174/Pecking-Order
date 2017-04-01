using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
public class OneCardManager : MonoBehaviour {

    public cardAsset card;
    public OneCardManager previewManager;

    //only for creatures
    private bool canAttack = false;

    [Header("Image References")]
    public Image cardImage;
    public Image level1;
    public Image level2;
    public Image level3;
    public Image typeImage;
    public Image glowImage;
    public Image cardBodyImage;

    
    [Header("Text References")]
    public Text manaText;
    public Text attackText;
    public Text names;
    public Text descriptionText;

    //these are all creature specific functions
    public bool CanAttackNow
    {
        get
        {
            return canAttack;
        }

        set
        {
            canAttack = value;

            glowImage.enabled = value;
        }

    }

    void Awake()
    {
        if (card != null)
            ReadCardFromAsset();
    }

    public void ReadCardFromAsset()
    {
        //null reference check
        if(card.characterAsset != null)
        {
            //change tint of the card
            cardBodyImage.color = card.characterAsset.typeCardTint;
        }

        names.text = card.name;
        
        manaText.text = card.ManaCost.ToString();
        descriptionText.text = card.Description;

        typeImage.sprite = card.typeImage;
        cardImage.sprite = card.CardImage;

        if(card.isCreature)
        {
            attackText.text = card.Attack.ToString();

            //destroy two image assets
            if (card.level == 1)
            {
                Destroy(level2);
                Destroy(level3);
            }

            //destroy 1 image assets
            else if (card.level == 2)
            {
                Destroy(level3);
            }
        }
        
        //we want a preview
        if(previewManager != null)
        {
            previewManager.card = card;
            previewManager.ReadCardFromAsset();
        }
    }


}
