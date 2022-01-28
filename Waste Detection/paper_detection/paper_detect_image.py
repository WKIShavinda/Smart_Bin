import cv2 as cv

def paper_detect():
    #reading and displaying original image
    img = cv.imread('Photos/paper2.jpg')
    #cv.imshow('Original', img)

    #converting image to grayscale
    gray = cv.cvtColor(img, cv.COLOR_BGR2GRAY)
    #cv.imshow('Gray Scale', gray)

    #reading xml files
    haar_cascadepaper_1 = cv.CascadeClassifier('paper_1.xml')
    haar_cascadepaper_2 = cv.CascadeClassifier('paper_2.xml')
    haar_cascadepaper_3 = cv.CascadeClassifier('paper_3.xml')

    paper_1 = haar_cascadepaper_1.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=1)
    paper_2 = haar_cascadepaper_2.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=1)
    paper_3 = haar_cascadepaper_3.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=3)

    #detecting the paper
    for (x, y, w, h) in paper_1:
            cv.rectangle(img, (x, y), (x+w, y+h), (0, 255, 0), thickness=2) #lime color

    for (a, b, c, d) in paper_2:
        cv.rectangle(img, (a, b), (a+c, b+d), (255, 0, 0), thickness=2) #red color

    for (p, q, r, s) in paper_3:
        cv.rectangle(img, (p, q), (p+r, q+s), (0, 0, 255), thickness=2) #blue color

    #Resizing images
    def rescaleFrame(frame, scale=0.5):
        width = int(frame.shape[1] * scale)
        height = int(frame.shape[0] * scale)

        dimensions = (width, height)

        return cv.resize(frame, dimensions, interpolation=cv.INTER_AREA)

    resized_image = rescaleFrame(img)
    cv.imshow('Resized detected images', resized_image)

    #printing number of paper
    print(f'Number of paper found = {len(paper_1) + len(paper_2) + len(paper_3)}')

    #Checking paper found or not
    if len(paper_1) or len(paper_2) or len(paper_3):
        print("Paper found")
    else:
        print("Paper not found")

    cv.waitKey(0)

if __name__ == "__main__":
    paper_detect()