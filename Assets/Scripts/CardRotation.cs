using System.Collections;
using UnityEngine;

[ExecuteInEditMode]
public class CardRotation : MonoBehaviour {

    public RectTransform CardFront;
    public RectTransform CardBack;

    public Transform targetFacePoint;
	
    public Collider col;

    private bool showingBack = false;

	// Update is called once per frame
	void Update () {
        RaycastHit[] hits;

        hits = Physics.RaycastAll(origin: Camera.main.transform.position, 
            direction: (-Camera.main.transform.position + targetFacePoint.position).normalized, 
            maxDistance: (-Camera.main.transform.position + targetFacePoint.position).magnitude);

        bool passedCard = false;

        foreach(RaycastHit h in hits)
        {
            if (h.collider == col)
                passedCard = true;
        }

        if(passedCard != showingBack)
        {
            showingBack = passedCard;

            if (showingBack)
            {
                CardFront.gameObject.SetActive(false);
                CardBack.gameObject.SetActive(true);
            }

            else
            {
                CardFront.gameObject.SetActive(true);
                CardBack.gameObject.SetActive(false);
            }
        }
	}
}
