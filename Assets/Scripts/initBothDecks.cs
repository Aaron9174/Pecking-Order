using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class initBothDecks : MonoBehaviour {

	// Use this for initialization
	void Start () {
        char[] seperators = {':'};
        string url = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/multiplayer.php";
        WWWForm form = new WWWForm();
        form.AddField("getDeck", "true");
        form.AddField("username", PlayerPrefs.GetString("username"));
        WWW w = new WWW(url, form);
        while (!w.isDone) { }
        string result = w.text;
        string[] cards = result.Split(seperators, StringSplitOptions.RemoveEmptyEntries);
        for(int i=0;i<cards.Length;i++)
        {
            int place = 0;
            if(cards[place]=="Animal")
            {
                place += 6;
                //name,attack,sacrifice,mana,type
                //put these into some kind of card objects to easily fill in the card pre-fab

            } else
            {
                place += 4;
                //name,mana,effect
                //same
            }
        }
    }
	
	// Update is called once per frame
	void Update () {
		
	}
}
