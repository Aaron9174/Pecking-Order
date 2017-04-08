using UnityEngine;
using System;
using System.Linq;
using System.Collections;
using System.Collections.Generic;

public class variableLengthFriends : MonoBehaviour {

    public GameObject[] slots;

    //result will hold the number of friends that this user has online right
    public int calculateLength()
    {
        string URL = "http://test1.xu4qu3w2zy.us-east-1.elasticbeanstalk.com/player.php";
        WWWForm form = new WWWForm();
        form.AddField("friendCount", "true");
        form.AddField("username", PlayerPrefs.GetString("username"));
        WWW w = new WWW(URL, form);
        while (!w.isDone) { }
        string result = w.text;
        Debug.Log("HERERERRRE\n");
        Debug.Log(result);

        return Int32.Parse(result);
    }

    public void position(GameObject[] slots)
    {
        Vector3 mv = new Vector3(0, 0, 0);
        for(int i = 0; i < slots.Length; i++)
        {
            mv.y = 25 * i;

            slots[i].transform.position = mv;
        }
    }

    public void organize()
    {
        int length = calculateLength();

        Debug.Log("Here.\n");

        if(length != 0)
        {
            GameObject[] slots = new GameObject[length];

            position(slots);
        } 
    }
}
