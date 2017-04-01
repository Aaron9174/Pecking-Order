using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class draggingBasics : MonoBehaviour {

    //this will ecide whether we use the displacement or not
    public bool use_Displacement = true;

    //boolean indicates that it is dragging
    private bool dragging = false;

    //mouse to camera on z-axis
    private float z_displacement;

    //Thsi represents the distance from the click to the middle of the game Object
    private Vector3 pointer_Displacement = Vector3.zero;

    void OnMouseDown()
    {
        dragging = true;

        z_displacement = -Camera.main.transform.position.z + transform.position.z;

        if (use_Displacement)
            pointer_Displacement = -transform.position + MouseWorldCoord();
    }

    // Update is called once per frame
    void Update () {

        //are we dragging?
        if (dragging)
        {
            //if we are find the coordinates of the mouse
            Vector3 mousePos = MouseWorldCoord();

            //position of the card is updated to new vector with appropriate displacements
            transform.position = new Vector3(mousePos.x - pointer_Displacement.x, mousePos.y - pointer_Displacement.y, transform.position.z);
        }
            
	}

    private void OnMouseUp()
    {
        if (dragging)
            dragging = false;
    }

    private Vector3 MouseWorldCoord()
    {
        Vector3 screenMousePos = Input.mousePosition;

        screenMousePos.z = z_displacement;

        return Camera.main.ScreenToWorldPoint(screenMousePos);
    }
}
