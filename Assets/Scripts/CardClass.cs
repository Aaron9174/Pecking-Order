using System.Collections;
using System.Collections.Generic;
using UnityEngine;
namespace deck
{

    public class CardClass : MonoBehaviour
    {
        public string cardName;
        public int mana;
        public int attack;
        public string type;
        public string effect;

        public CardClass(string name, int mana, int attack, string type)
        {
            this.cardName = name;
            this.mana = mana;
            this.attack = attack;
            this.type = type;
        }

        public CardClass(string name, int mana, string effect)
        {
            this.cardName = name;
            this.mana = mana;
            this.effect = effect;
        }
    }
}
