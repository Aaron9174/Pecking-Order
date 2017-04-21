using UnityEngine;
using System;
using System.Linq;
using System.Collections;
using System.Collections.Generic;
using UnityEngine.UI;

public class variableLengthFriends : MonoBehaviour
{

    public GameObject slot;
    public GameObject temp;
    private GameObject[] slots;
    private int length;
    string URL = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/player.php";
    public void activate()
    {
        if (temp.activeSelf == true)
            temp.SetActive(false);
        else
            temp.SetActive(true);
    }

    //result will hold the number of friends that this user has online right
    public int calculateLength()
    {
        WWWForm form = new WWWForm();
        form.AddField("friendCount", "true");
        form.AddField("username", PlayerPrefs.GetString("username"));
        WWW w = new WWW(URL, form);
        while (!w.isDone) { }
        string result = w.text;

        Debug.Log(result);

        return Int32.Parse(result);
    }

    public void position(GameObject[] slots, Vector3 mv)
    {
        for (int i = 0; i < slots.Length; i++)
        {
            mv.y = 25 * i;

            slots[i].transform.position = mv;
        }
    }

    public String[] getUsernames()
    {
        WWWForm form = new WWWForm();
        string[] separators = { ":" };
        form.AddField("friendArray", "true");
        form.AddField("username", PlayerPrefs.GetString("username"));
        WWW w = new WWW("http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/player.php", form);
        while (!w.isDone) { }
        String result = w.text;

        string[] friends = result.Split(separators, StringSplitOptions.RemoveEmptyEntries);

        return friends;
    }

    public void organize()
    {
        bool updateFriends = false;

        if (temp.activeSelf == false)
        {
            updateFriends = true;
            activate();
        }

        else
        {
            updateFriends = false;
            activate();
        }


        if (updateFriends)
        {
            //this array hold all of the names of the friends this user has that are now online
            String[] friendArray = getUsernames();

            length = calculateLength();

            slots = new GameObject[length];

            Debug.Log("length = " + length);

            slot.SetActive(false);

            if (length >= 1)
            {
                slot.SetActive(true);
                slot.GetComponentInChildren<Text>().text = friendArray[0];
            }


            if (length != 0)
            {
                Vector3 mv = slot.transform.position;

                Debug.Log("slot position = " + slot.transform.position);
                for (int i = 0; i < length - 1; i++)
                {

                    Debug.Log(friendArray[i]);
                    slots[i] = Instantiate(slot, slot.transform.position, Quaternion.identity, slot.transform.parent);
                    slots[i].SetActive(true);
                    slots[i].GetComponentInChildren<Text>().text = friendArray[i + 1];

                    mv.y = mv.y - 4;
                    slots[i].transform.position = mv;

                }
            }
        }

        else
        {
            for (int i = 0; i < length; i++)
                Destroy(slots[i]);
        }

    }
}

