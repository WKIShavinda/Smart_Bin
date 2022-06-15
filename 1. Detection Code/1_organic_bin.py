import cv2 as cv
import serial
import time

def waste_detect_live():

    ard = serial.Serial('COM5', 115200)
    time.sleep(2)   #wait for 2s
     
    print(ard.readline())

    #Paper XML files
    haar_cascadepaper_1 = cv.CascadeClassifier(r'XML files\paper_1.xml')
    haar_cascadepaper_2 = cv.CascadeClassifier(r'XML files\paper_2.xml')
    haar_cascadepaper_3 = cv.CascadeClassifier(r'XML files\paper_3.xml')
    haar_cascadepaper_4 = cv.CascadeClassifier(r'XML files\paper_4.xml')
    haar_cascadepaper_5 = cv.CascadeClassifier(r'XML files\paper_5.xml')
    haar_cascadepaper_6 = cv.CascadeClassifier(r'XML files\paper_6.xml')
    haar_cascadepaper_7 = cv.CascadeClassifier(r'XML files\paper_7.xml')
    haar_cascadepaper_8 = cv.CascadeClassifier(r'XML files\paper_8.xml')

    #Plastic XML files
    haar_cascadeplastic_1 = cv.CascadeClassifier(r'XML files\plastic_1.xml')
    haar_cascadeplastic_2 = cv.CascadeClassifier(r'XML files\plastic_2.xml')
    haar_cascadeplastic_3 = cv.CascadeClassifier(r'XML files\plastic_3.xml')
    haar_cascadeplastic_4 = cv.CascadeClassifier(r'XML files\plastic_4.xml')
    haar_cascadeplastic_5 = cv.CascadeClassifier(r'XML files\plastic_5.xml')
    haar_cascadeplastic_6 = cv.CascadeClassifier(r'XML files\plastic_6.xml')
    haar_cascadeplastic_7 = cv.CascadeClassifier(r'XML files\plastic_7.xml')

    #cap = cv.VideoCapture(0)
    cap = cv.VideoCapture("http://192.168.1.108:81/stream")

    while True:

        _, img = cap.read()

        gray = cv.cvtColor(img, cv.COLOR_BGR2GRAY)

        #Paper
        paper_1 = haar_cascadepaper_1.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        paper_2 = haar_cascadepaper_2.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        paper_3 = haar_cascadepaper_3.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        paper_4 = haar_cascadepaper_4.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        paper_5 = haar_cascadepaper_5.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        paper_6 = haar_cascadepaper_6.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        paper_7 = haar_cascadepaper_7.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        paper_8 = haar_cascadepaper_8.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)

        #Plastic
        plastic_1 = haar_cascadeplastic_1.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_2 = haar_cascadeplastic_2.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_3 = haar_cascadeplastic_3.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_4 = haar_cascadeplastic_4.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_5 = haar_cascadeplastic_5.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_6 = haar_cascadeplastic_6.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_7 = haar_cascadeplastic_7.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)

        #Paper
        for (x, y, w, h) in paper_1:
            cv.rectangle(img, (x, y), (x+w, y+h), (0, 0, 255), thickness=2) #blue color

        for (a, b, c, d) in paper_2:
            cv.rectangle(img, (a, b), (a+c, b+d), (0, 0, 255), thickness=2) #blue color

        for (p, q, r, s) in paper_3:
            cv.rectangle(img, (p, q), (p+r, q+s), (0, 0, 255), thickness=2) #blue color

        for (p, q, r, s) in paper_4:
            cv.rectangle(img, (p, q), (p+r, q+s), (0, 0, 255), thickness=2) #blue color

        for (p, q, r, s) in paper_5:
            cv.rectangle(img, (p, q), (p+r, q+s), (0, 0, 255), thickness=2) #blue color

        for (p, q, r, s) in paper_6:
            cv.rectangle(img, (p, q), (p+r, q+s), (0, 0, 255), thickness=2) #blue color

        for (p, q, r, s) in paper_7:
            cv.rectangle(img, (p, q), (p+r, q+s), (0, 0, 255), thickness=2) #blue color

        for (p, q, r, s) in paper_8:
            cv.rectangle(img, (p, q), (p+r, q+s), (0, 0, 255), thickness=2) #blue color

        #Plastic
        for (x, y, w, h) in plastic_1:
            cv.rectangle(img, (x, y), (x+w, y+h), (255, 0, 0), thickness=2) #red color

        for (x, y, w, h) in plastic_2:
            cv.rectangle(img, (x, y), (x+w, y+h), (255, 0, 0), thickness=2) #red color

        for (x, y, w, h) in plastic_3:
            cv.rectangle(img, (x, y), (x+w, y+h), (255, 0, 0), thickness=2) #red color

        for (x, y, w, h) in plastic_4:
            cv.rectangle(img, (x, y), (x+w, y+h), (255, 0, 0), thickness=2) #red color

        for (x, y, w, h) in plastic_5:
            cv.rectangle(img, (x, y), (x+w, y+h), (255, 0, 0), thickness=2) #red color

        for (x, y, w, h) in plastic_6:
            cv.rectangle(img, (x, y), (x+w, y+h), (255, 0, 0), thickness=2) #red color

        for (x, y, w, h) in plastic_7:
            cv.rectangle(img, (x, y), (x+w, y+h), (255, 0, 0), thickness=2) #red color


        cv.imshow('Video capture', img)

        k = cv.waitKey(30) & 0xff
        if k==27:
            break


        if (len(paper_1) or len(paper_2) or len(paper_3) or len(paper_4) or len(paper_5) or len(paper_6) or len(paper_7) or len(paper_8) or
            len(plastic_1) or len(plastic_2) or len(plastic_3) or len(plastic_4) or len(plastic_5) or len(plastic_6) or len(plastic_7)):

            print(f'{len(paper_1) + len(paper_2) + len(paper_3) + len(paper_4) + len(paper_5) + len(paper_6) + len(paper_7) + len(paper_8)} paper found')
            print(f'{len(plastic_1) + len(plastic_2) + len(plastic_3) + len(plastic_4) + len(plastic_5) + len(plastic_6) + len(plastic_7)} plastic found ')

            var = '1'

        else:

            print(f'{len(paper_1) + len(paper_2) + len(paper_3) + len(paper_4) + len(paper_5) + len(paper_6) + len(paper_7) + len(paper_8)} paper found')
            print(f'{len(plastic_1) + len(plastic_2) + len(plastic_3) + len(plastic_4) + len(plastic_5) + len(plastic_6) + len(plastic_7)} plastic found ')

            var = '0'


        if var == '1':
            ard.write(b'1')
            
            time.sleep(3)

        elif var == '0':
            ard.write(b'0')

            time.sleep(3)

    cap.release()


if __name__ == "__main__":
    waste_detect_live()