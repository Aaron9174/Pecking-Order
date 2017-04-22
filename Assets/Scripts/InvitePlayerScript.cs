using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;

public class InvitePlayerScript : MonoBehaviour
{

    public GameObject input;
    public GameObject notAFriend;
    private string username;

    public void startGame()
    {
        string url = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/multiplayer.php";
        string username = input.GetComponent<InputField>().text;
        if (username != "")
        {
            WWWForm form = new WWWForm();
            form.AddField("username1", PlayerPrefs.GetString("username"));
            form.AddField("username2", username);
            form.AddField("invitePlayer", "true");
            WWW w = new WWW(url, form);

            SceneManager.LoadScene("BattleScene");
        }  else {
            //notAFriend.SetActive(true);
        }
    }
}
