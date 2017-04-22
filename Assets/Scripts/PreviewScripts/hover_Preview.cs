using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using DG.Tweening;

public class hover_Preview : MonoBehaviour {

    //all used to specify what we want in inspector
    public GameObject card;
    public Vector3 targetPosition;
    public float targetScale;
    public GameObject previewGameObject;
    public bool awakeMode = false;

    //used privately in the code
    private static hover_Preview currentlyViewing = null;
    private static bool previewAllowed = true;

    //setter and getter for the previewAllowedVar
    private static bool PreviewAllowed
    {
        get
        {
            return previewAllowed;
        }

        set
        {
            previewAllowed = value;

            if (!previewAllowed)
                StopAllPreviews();
        }
    }

    private bool enablePreview = false;

    public bool EnablePreview
    {
        get { return enablePreview; }

        set
        {
            enablePreview = value;
            if (!enablePreview)
                StopThisPreview();
        }
    }

    public bool overCollider { get; set; }

    void Awake()
    {
        EnablePreview = awakeMode;
    }

    void OnMouseEnter()
    {
        overCollider = true;

        if (previewAllowed && EnablePreview)
            PreviewThisCard();

    }

    private void OnMouseDown()
    {
        overCollider = false;
        if (!PreviewingCard())
            StopAllPreviews();
    }

    void OnMouseExit()
    {
        overCollider = false;

        if (!PreviewingCard())
            StopAllPreviews();
    }

    void PreviewThisCard()
    {
        Debug.Log("Here");
        //stop all previews before beginning a new preview
        StopAllPreviews();

        //save current hover preview
        currentlyViewing = this;

        //enable preview game object
        previewGameObject.SetActive(true);

        //disbaled the card behind the preview
        if (card != null)
            card.SetActive(false);

        //reset the position of the previewGameObject from previous preview
        previewGameObject.transform.localPosition = Vector3.zero;
        previewGameObject.transform.localScale = Vector3.one;

        //tween to the size we want
        previewGameObject.transform.DOLocalMove(targetPosition, 1f).SetEase(Ease.OutQuint);
        previewGameObject.transform.DOScale(targetScale, 1f).SetEase(Ease.OutQuint);
    }

    void StopThisPreview()
    {
        //set the preview gameobject so it can be seen
        previewGameObject.SetActive(false);

        //reset the scale and position
        previewGameObject.transform.localScale = Vector3.one;
        previewGameObject.transform.localPosition = Vector3.zero;

        //allow for the card to be seen underneath
        if (card != null)
            card.SetActive(true);
    }

    //stops all previews
    private static void StopAllPreviews()
    {
        if (currentlyViewing != null)
        {
            //turn off the previewing object
            currentlyViewing.previewGameObject.SetActive(false);

            //scale it to the size of the card
            currentlyViewing.previewGameObject.transform.localScale = Vector3.one;

            //now makes it position the card as well
            currentlyViewing.previewGameObject.transform.localPosition = Vector3.zero;

            //turn card back on
            if (currentlyViewing.card != null)
                currentlyViewing.card.SetActive(true); 

        }
    }

    private static bool PreviewingCard()
    {
        if (!PreviewAllowed)
            return false;

        hover_Preview[] allHovers = GameObject.FindObjectsOfType<hover_Preview>();

        foreach(hover_Preview i in allHovers)
        {
            if (i.overCollider && i.EnablePreview)
                return true;
        }

        return false;
    }
}
