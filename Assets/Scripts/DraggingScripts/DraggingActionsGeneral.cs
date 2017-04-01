using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public abstract class DraggingActionsGeneral : MonoBehaviour {

    //we are starting to drag
    public abstract void OnStartDrag();

    //we are ending the drag process
    public abstract void OnEndDrag();

    //deagging during update function
    public abstract void OnDraggingInUpdate();

    //tells us if we can drag the object or not
    public virtual bool CanDrag
    {
        get
        {
            return true;
        }
    }
}
