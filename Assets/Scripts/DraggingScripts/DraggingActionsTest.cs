using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class DraggingActionsTest : MonoBehaviour {

    //use displacement or not?
    public bool useDisplacement;

    //will give us the option for actions to occur
    private DraggingActionsGeneral dragging_action;

    //indicates if we are dragging or not
    private bool dragging = false;

    //gives displacement between mouse and the current position of the object
    private Vector3 pointDisplacement = Vector3.zero;

    //maintain z distance
    private float zDisplacement;

    //happens right when the game loads in
    public void Awake()
    {
        //defines what extension of the abstract class we will be using
        dragging_action = GetComponent<DraggingActionsExtend>();
    }

    //when we click down
    public void OnMouseDown()
    {
        //if the object can be dragged
        if(dragging_action.CanDrag)
        {
            dragging = true;
            dragging_action.OnStartDrag();

            zDisplacement = -Camera.main.transform.position.z + transform.position.z;

            if (useDisplacement)
            {
                pointDisplacement = transform.position + MouseWorldCoord();
            }

            else
                pointDisplacement = Vector3.zero;
        }
    }

    //update every frame
    public void Update()
    {
        //we are current in the process of dragging the card
        if(dragging)
        {
            //find the current mouse location
            Vector3 mouseLoc = MouseWorldCoord();

            //perform some action
            dragging_action.OnDraggingInUpdate();

            //update transform position based on displacement
            transform.position = new Vector3(mouseLoc.x - pointDisplacement.x, mouseLoc.y - pointDisplacement.y, transform.position.z);
        }
    }

    //lifting finger off of the mouse
    public void OnMouseUp()
    {
        if(dragging)
        {
            //stop dragging
            dragging = false;

            //perform some ending action
            dragging_action.OnEndDrag();
        }
    }

    //returns mouse coordinate to a usable world coordinate
    private Vector3 MouseWorldCoord()
    {
        //find location of the mouse
        Vector3 screenMousePos = Input.mousePosition;

        //ensure the card stays the same z distances away
        screenMousePos.z = zDisplacement;

        //return world point values
        return Camera.main.ScreenToWorldPoint(screenMousePos);
    }

}
