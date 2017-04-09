using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
using System.Collections;
using System;
using System.Text.RegularExpressions;

public class LogoutServer : MonoBehaviour
{
    public void logout()
    {
        string loginURL = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/";
        WWWForm form = new WWWForm();
        form.AddField("logout", "true");
        string username = PlayerPrefs.GetString("username");
        form.AddField("username", username);
        Debug.Log(username);
        WWW w = new WWW(loginURL, form);
        while (!w.isDone) { }
        string result = w.text;
        if (result == "logout")
        {
            Debug.Log("LogOut was successful");
            Debug.Log(result);
            SceneManager.LoadScene("Login Menu");
        }
        else
        {
            Debug.Log(result);
            Debug.Log("the players logout was not recorded");
        }
    }
}
