using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class DenyScript : MonoBehaviour {
    public GameObject panel;
    string url = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/multiplayer.php";
    public void denyGame()
    {
        WWWForm form = new WWWForm();
        form.AddField("username", PlayerPrefs.GetString("username"));
        form.AddField("denyGame", "true");
        WWW w = new WWW(url, form);
        panel.SetActive(false);
    }
}
