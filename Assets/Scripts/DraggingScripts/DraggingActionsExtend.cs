using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using DG.Tweening;

public class DraggingActionsExtend : DraggingActionsGeneral {

    //declaration
    Vector3 savedPos;

    //just save the original location
    public override void OnStartDrag()
    {
        savedPos = transform.position;
    }

    //lets not do anything here
    public override void OnDraggingInUpdate() { }

    //what do we do on the end of a drag process
    public override void OnEndDrag()
    {
        //this will move the object all nice like
        transform.DOMove(savedPos, 1f).SetEase(Ease.OutQuint); 
    }
}
