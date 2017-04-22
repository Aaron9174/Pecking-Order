using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class EndTurn : MonoBehaviour {
    public Text mana;
    public Text mana2;
	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
		
	}

    public void turnEnd()
    {
        /*char[] seperators = { ':' };
        string url = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/multiplayer.php";
        WWWForm form = new WWWForm();
        form.AddField("turn", 1);
        form.AddField("gameID", 1);
        form.AddField("username", PlayerPrefs.GetString("username"));
        WWW w = new WWW(url, form);
        while(!w.isDone) { }
        string result = w.text;
        Debug.Log(result + "this is the mana");
        string[] manaArray = result.Split(seperators, StringSplitOptions.RemoveEmptyEntries);*/
        mana.text = Convert.ToString(Convert.ToInt32(mana.text) + 1);
        mana2.text = Convert.ToString(Convert.ToInt32(mana.text) - 1);
    }
}
