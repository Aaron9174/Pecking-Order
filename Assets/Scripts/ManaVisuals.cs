using UnityEngine;
using UnityEngine.UI;

[ExecuteInEditMode]
public class ManaVisuals : MonoBehaviour {

    //will be used to see the max crystals and how many we currently have
    public int TestCurrentCrystals;
    public int TestTotalCrystals;

    //used for the storing of crystal gameobjects as well as the text for the mana
    public Image[] crystals;
    public Text manaText;

    //total number of crystals we have
    private int totalCrystals;

    private int currentCrystals;

    //get and setter
    public int TotalCrystals
    {
        get
        {
            return totalCrystals;
        }

        set
        {
            //ensure we dont go ever array length
            if (value > crystals.Length)
                totalCrystals = crystals.Length;

            //ensure that we dont go under zero crystals
            else if (value < 0)
                totalCrystals = 0;

            //otherwise we are good
            else
                totalCrystals = value;


            
            for (int i = 0; i < crystals.Length; i++)
            {
                
                //for values of i less than the max, set them to be seen
                if (i < totalCrystals)
                {
                    if (crystals[i].color == Color.clear)
                        crystals[i].color = Color.gray;
                }

                //otherwise make it so they cant be seen
                else
                {
                   crystals[i].color = Color.clear;
                }
                   
            }

            //sets text to what the current and total crystals are
            manaText.text = string.Format("{0}/{1}", currentCrystals.ToString(), totalCrystals.ToString());
           
        }
    }

    //getter and setter for currentCrystals
    public int CurrentCrystals
    {
        //get the current crystal amount
        get
        {
            return currentCrystals;
        }

        //sets the value for the current amount of crystals
        set
        {
            //make sure we are not over array length
            if (value > totalCrystals)
                currentCrystals = totalCrystals;

            //make sure we have minimum zero crystals and no less
            else if (value < 0)
                currentCrystals = 0;

            //other wise the value is good
            else
                currentCrystals = value;

            //loop through the crystals
            for(int i = 0; i < totalCrystals; i++)
            {
                //for crystals less than what we current have, set them to be able to see
                if (i < currentCrystals)
                    crystals[i].color = Color.white;

                //otherwise dont
                else
                    crystals[i].color = Color.gray;
            }

            //update mana text
            manaText.text = string.Format("{0}/{1}", currentCrystals.ToString(), totalCrystals.ToString());
        }
    }

    //calls every frame
    private void Update()
    {
        //check to make sure we arent ingame and we are inside the editor
        if(Application.isEditor && !Application.isPlaying)
        {

            //update crystals with public var information from the inspector
            TotalCrystals = TestTotalCrystals;
            CurrentCrystals = TestCurrentCrystals;
        }
    }
}
