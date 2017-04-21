using UnityEngine;
using System;
using System.Linq;
using System.Collections;
using System.Collections.Generic;

namespace deck
{
    public class Deck : MonoBehaviour
    {
        List<GameObject> deck = new List<GameObject>();
        public GameObject CreatureCard;
        public GameObject SpellCard;
        // Use this for initialization
        void Start()
        {
            char[] seperators = { ':' };
            string url = "http://gamephp2.hmktqg5mmp.us-east-1.elasticbeanstalk.com/multiplayer.php";
            WWWForm form = new WWWForm();
            form.AddField("getDeck", "true");
            form.AddField("username", PlayerPrefs.GetString("username"));
            WWW w = new WWW(url, form);
            while (!w.isDone) { }
            string result = w.text;
            string[] cards = result.Split(seperators, StringSplitOptions.RemoveEmptyEntries);
            for (int i = 0; i < cards.Length; i++)
            {
                int place = 0;
                if (cards[place] == "Animal")
                {
                    place += 5;
                    deck.Add(Instantiate(CreatureCard, CreatureCard.transform.position, Quaternion.identity, CreatureCard.transform.parent));
                    //name,attack,mana,type
                    //put these into some kind of card objects to easily fill in the card pre-fab
                }
                else
                {
                    place += 4;
                    deck.Add(Instantiate(SpellCard, SpellCard.transform.position, Quaternion.identity, SpellCard.transform.parent));
                }
            }
        }
    }
}
