using UnityEngine;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
using System.Collections;
using System;
using System.Text.RegularExpressions;

public class Logout : MonoBehaviour
{
	public void logout()
    {
        string loginURL = "http://test1.xu4qu3w2zy.us-east-1.elasticbeanstalk.com/";
        WWWForm form = new WWWForm();
        form.AddField("logout", "true");
        string username = PlayerPrefs.GetString("username");
        form.AddField("username", username);
        WWW w = new WWW(loginURL, form);
        while(!w.isDone) {}
        string result = w.text;
        if(result=="logout")
        {
            Debug.Log("LogOut was successful");
            SceneManager.LoadScene("Login Menu");
        }
        else
        {
            Debug.Log(result);
            Debug.Log("the players logout was not recorded");
        }
    }
}
