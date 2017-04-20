using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class AcceptScript : MonoBehaviour {

    public void AcceptClick()
    {
        string url = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/multiplayer.php";
        WWWForm form = new WWWForm();
        form.AddField("joinGame", "true");
        form.AddField("username", PlayerPrefs.GetString("username"));
        WWW w = new WWW(url, form);
        while(!w.isDone) { }
        string result = w.text;
        PlayerPrefs.SetString("turn",result);
        SceneManager.LoadScene("BattleScene");
    }
}
