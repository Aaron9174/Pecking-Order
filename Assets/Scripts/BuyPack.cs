using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BuyPack : MonoBehaviour {

    public GameObject bought;
    public GameObject card1;
    public GameObject card2;
    public GameObject card3;
    public GameObject card4;
    public GameObject card5;

    public void PackBuy()
    {
        string url = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/deckBuilder.php";
        WWWForm form = new WWWForm();
        form.AddField("buyPack", "true");
        form.AddField("username", PlayerPrefs.GetString("username"));
        WWW w = new WWW(url, form);
        while(!w.isDone) { }
        string result = w.text;
        Debug.Log(result);
        bought.SetActive(true);
        card1.SetActive(true);
        card2.SetActive(true);
        card3.SetActive(true);
        card4.SetActive(true);
        card5.SetActive(true);
    }
}
