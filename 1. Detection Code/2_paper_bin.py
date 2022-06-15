import cv2 as cv
import serial
import time

def waste_detect_live():

    ard = serial.Serial('COM5', 115200)
    time.sleep(2)   #wait for 2s
     
    print(ard.readline())

    #Organic XML files
    haar_cascadeorganic_1 = cv.CascadeClassifier(r'XML files\organic_1.xml')
    haar_cascadeorganic_2 = cv.CascadeClassifier(r'XML files\organic_2.xml')

    #Plastic XML files
    haar_cascadeplastic_1 = cv.CascadeClassifier(r'XML files\plastic_1.xml')
    haar_cascadeplastic_2 = cv.CascadeClassifier(r'XML files\plastic_2.xml')
    haar_cascadeplastic_3 = cv.CascadeClassifier(r'XML files\plastic_3.xml')
    haar_cascadeplastic_4 = cv.CascadeClassifier(r'XML files\plastic_4.xml')
    haar_cascadeplastic_5 = cv.CascadeClassifier(r'XML files\plastic_5.xml')
    haar_cascadeplastic_6 = cv.CascadeClassifier(r'XML files\plastic_6.xml')
    haar_cascadeplastic_7 = cv.CascadeClassifier(r'XML files\plastic_7.xml')

    #cap = cv.VideoCapture(0)
    #cap = cv.VideoCapture("http://192.168.1.24:81/stream")
    cap = cv.VideoCapture("http://192.168.0.101:81/stream")

    while True:

        _, img = cap.read()

        gray = cv.cvtColor(img, cv.COLOR_BGR2GRAY)

        #Organic
        organic_1 = haar_cascadeorganic_1.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=100)
        organic_2 = haar_cascadeorganic_2.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=100)

        #Plastic
        plastic_1 = haar_cascadeplastic_1.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_2 = haar_cascadeplastic_2.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_3 = haar_cascadeplastic_3.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_4 = haar_cascadeplastic_4.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_5 = haar_cascadeplastic_5.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_6 = haar_cascadeplastic_6.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)
        plastic_7 = haar_cascadeplastic_7.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=150)

        #Organic
        for (x, y, w, h) in organic_1:
            cv.rectangle(img, (x, y), (x+w, y+h), (0, 255, 0), thickness=2) #lime color

        for (a, b, c, d) in organic_2:
            cv.rectangle(img, (a, b), (a+c, b+d), (0, 255, 0), thickness=2) #lime color

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


        if (len(organic_1) or len(organic_2) or 
            len(plastic_1) or len(plastic_2) or len(plastic_3) or len(plastic_4) or len(plastic_5) or len(plastic_6) or len(plastic_7)):

            print(f'{len(organic_1) + len(organic_2)} organic found')
            print(f'{len(plastic_1) + len(plastic_2) + len(plastic_3) + len(plastic_4) + len(plastic_5) + len(plastic_6) + len(plastic_7)} plastic found ')

            var = '1'

        else:

            print(f'{len(organic_1) + len(organic_2)} organic found')
            print(f'{len(plastic_1) + len(plastic_2) + len(plastic_3) + len(plastic_4) + len(plastic_5) + len(plastic_6) + len(plastic_7)} plastic found ')

            var = '0'


        if var == '1':
            ard.write(b'1')
            
            time.sleep(0.5)

        elif var == '0':
            ard.write(b'0')

            time.sleep(0.5)

    cap.release()


if __name__ == "__main__":
    waste_detect_live()