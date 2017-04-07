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
    public GameObject same;
    public GameObject repeat;
    private string friendName;

    public void add()
    {
        string url = "http://test1.xu4qu3w2zy.us-east-1.elasticbeanstalk.com/player.php";
        WWWForm form = new WWWForm();
        friendName = friendInput.GetComponent<InputField>().text;
        Debug.Log(friendName);
        form.AddField("addFriend", "true");
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
            if (repeat.activeInHierarchy == true)
            {
                repeat.SetActive(false);
            }
            if (same.activeInHierarchy == true)
            {
                same.SetActive(false);
            }
            added.SetActive(true);
        }
        else if(result == "same")
        {
            if (invalidUsername.activeInHierarchy == true)
            {
                invalidUsername.SetActive(false);
            }
            if (added.activeInHierarchy == true)
            {
                added.SetActive(false);
            }
            if (repeat.activeInHierarchy == true)
            {
                repeat.SetActive(false);
            }
            same.SetActive(true);
        }
        else if(result == "repeat")
        {
            if (invalidUsername.activeInHierarchy == true)
            {
                invalidUsername.SetActive(false);
            }
            if (added.activeInHierarchy == true)
            {
                added.SetActive(false);
            }
            if (same.activeInHierarchy == true)
            {
                same.SetActive(false);
            }
            repeat.SetActive(true);
        }
        else
        {
            if (repeat.activeInHierarchy == true)
            {
                repeat.SetActive(false);
            }
            if (added.activeInHierarchy == true)
            {
                added.SetActive(false);
            }
            if (same.activeInHierarchy == true)
            {
                same.SetActive(false);
            }
            invalidUsername.SetActive(true);
        }
    }
}
