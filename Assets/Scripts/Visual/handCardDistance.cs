using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class handCardDistance : MonoBehaviour {

    public Transform[] children;

    void Awake()
    {
        //find the first and last positions
        Vector3 firstElementPosition = children[0].transform.position;
        Vector3 lastElementPosition = children[children.Length - 1].transform.position;


        //calculate the total distance between them
        Vector3 totalDistance = lastElementPosition - firstElementPosition;

        //then find the distance we want between each one
        Vector3 distanceBetween = totalDistance / (children.Length - 1);

        Debug.Log("first = "+firstElementPosition+"\nlast = "+lastElementPosition+"\ntotalDistance = "+totalDistance+"\ndistanceBetween = "+distanceBetween);

        //apply the distance
        for(int i = 1; i < children.Length-1; i++)
        {
            children[i].transform.position = children[i - 1].transform.position + distanceBetween;
        }
    }
}
