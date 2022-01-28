import cv2 as cv

def plastic_detect_live():

    haar_cascadeplastic_1 = cv.CascadeClassifier('plastic_cascade.xml')

    cap = cv.VideoCapture(0)

    while True:
        _, img = cap.read()

        gray = cv.cvtColor(img, cv.COLOR_BGR2GRAY)

        plastic_1 = haar_cascadeplastic_1.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=4)

        for (x, y, w, h) in plastic_1:
            cv.rectangle(img, (x, y), (x+w, y+h), (0, 255, 0), thickness=2) #lime color

        cv.imshow('Video capture', img)

        k = cv.waitKey(30) & 0xff
        if k==27:
            break

        if (len(plastic_1)):
            print(f'{len(plastic_1)} plastic found ')
        else:
            print("Plastic not found")

    cap.release()

if __name__ == "__main__":
    plastic_detect_live()