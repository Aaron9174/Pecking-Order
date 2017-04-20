using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CheckGame : MonoBehaviour {

    string username;
    string url;
    public GameObject panel;
	// Use this for initialization
	void Start () {
        this.username = PlayerPrefs.GetString("username");
        this.url = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/multiplayer.php";
        InvokeRepeating("checkForGame", 1.0f, 3.0f);
	}
	
    void checkForGame()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", username);
        WWW w = new WWW(url, form);
        while (!w.isDone) { }
        string result = w.text;
        if(result =="canJoin")
        {
            panel.SetActive(true);
        }
    }
}
