using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class RevealFriendsPanel : MonoBehaviour {

    public GameObject temp; 

    public void activate()
    {
        if (temp.activeSelf == true)
            temp.SetActive(false);
        else
            temp.SetActive(true);      
    }
}
