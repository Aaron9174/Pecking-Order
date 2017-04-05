using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class addFriend : MonoBehaviour
{
    public GameObject invalidUsername;
    public GameObject added;
    public GameObject friendInput;
    private string friendName;

    public void add()
    {
        string url = "http://test1.xu4qu3w2zy.us-east-1.elasticbeanstalk.com/player.php";
        WWWForm form = new WWWForm();
        friendName = friendInput.GetComponent<InputField>().text;
        Debug.Log(friendName);
        form.AddField("friend", friendName);
        form.AddField("username", PlayerPrefs.GetString("username"));
        WWW w = new WWW(url, form);
        while (!w.isDone) { }
        string result = w.text;
        Debug.Log(result);

        if (result == "added")
        {
            if (invalidUsername.activeInHierarchy == true)
            {
                invalidUsername.SetActive(false);
            }
            added.SetActive(true);
        }
        else
        {
            if (added.activeInHierarchy == true)
            {
                added.SetActive(false);
            }
            invalidUsername.SetActive(true);
        }
    }
}
