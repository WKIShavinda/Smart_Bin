import cv2 as cv
import serial
import time

def paper_detect_live():

    haar_cascadepaper_1 = cv.CascadeClassifier('paper_1.xml')
    haar_cascadepaper_2 = cv.CascadeClassifier('paper_2.xml')
    haar_cascadepaper_3 = cv.CascadeClassifier('paper_3.xml')

    cap = cv.VideoCapture(0)

    while True:
        _, img = cap.read()

        gray = cv.cvtColor(img, cv.COLOR_BGR2GRAY)

        paper_1 = haar_cascadepaper_1.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=1)
        paper_2 = haar_cascadepaper_2.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=1)
        paper_3 = haar_cascadepaper_3.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=1)

        for (x, y, w, h) in paper_1:
            cv.rectangle(img, (x, y), (x+w, y+h), (0, 255, 0), thickness=2) #lime color

        for (a, b, c, d) in paper_2:
            cv.rectangle(img, (a, b), (a+c, b+d), (255, 0, 0), thickness=2) #red color

        for (p, q, r, s) in paper_3:
            cv.rectangle(img, (p, q), (p+r, q+s), (0, 0, 255), thickness=2) #blue color

        cv.imshow('Video capture', img)

        k = cv.waitKey(30) & 0xff
        if k==27:
            break

        if (len(paper_1) or len(paper_2) or len(paper_3)):
            print(f'{len(paper_1) + len(paper_2) + len(paper_3)} paper found')
        else:
            print("Paper not found")

    cap.release()

if __name__ == "__main__":
    ard = serial.Serial("COM7", 115200)
    paper_detect_live()