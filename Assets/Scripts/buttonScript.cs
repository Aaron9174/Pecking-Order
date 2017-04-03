using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class buttonScript : MonoBehaviour
{
    public void nextLevel(int order)
    {
        SceneManager.LoadScene(order);
    }
}
