using UnityEngine;
using System;
using System.Linq;
using System.Collections;
using System.Collections.Generic;

namespace deck
{
    public class Deck : MonoBehaviour
    {
        //List<GameObject> deck = new List<GameObject>();
        List<CardClass> deck = new List<CardClass>();
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
            int place = 0;
            while(place<cards.Length)
            {
                if (cards[place] == "Animal")
                {
                    place += 5;
                    CardClass card = new CardClass(cards[place + 1], Convert.ToInt32(cards[place + 2]), Convert.ToInt32(cards[place + 3]), cards[place + 4]);
                    //deck.Add(Instantiate(CreatureCard, CreatureCard.transform.position, Quaternion.identity, CreatureCard.transform.parent));
                    //GameObject card = Instantiate(Resources.Load("Assets/Prefabs/CreatureCard")) as GameObject;

                    deck.Add(card);
                    //name,attack,mana,type
                    //put these into some kind of card objects to easily fill in the card pre-fab
                }
                else
                {
                    place += 4;
                    CardClass card = new CardClass(cards[place + 1], Convert.ToInt32(cards[place + 2]),cards[place + 4]);
                    //deck.Add(Instantiate(SpellCard, SpellCard.transform.position, Quaternion.identity, SpellCard.transform.parent));
                    deck.Add(card);
                }
            }
        }
    }
}
