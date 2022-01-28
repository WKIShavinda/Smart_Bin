import cv2 as cv

def plastic_detect():

    #reading and displaying original image
    img = cv.imread('Photos/plastic5.jpg')
    #cv.imshow('Original', img)

    #converting image to grayscale
    gray = cv.cvtColor(img, cv.COLOR_BGR2GRAY)
    #cv.imshow('Gray Scale', gray)

    #reading xml files
    haar_cascadeplastic_1 = cv.CascadeClassifier('plastic_cascade.xml')

    plastic_1 = haar_cascadeplastic_1.detectMultiScale(gray, scaleFactor=1.1, minNeighbors=1)

    #detecting the plastic
    for (x, y, w, h) in plastic_1:
        cv.rectangle(img, (x, y), (x+w, y+h), (0, 0, 255), thickness=2) #red color

    #Resizing images
    def rescaleFrame(frame, scale=0.5):
        width = int(frame.shape[1] * scale)
        height = int(frame.shape[0] * scale)

        dimensions = (width, height)

        return cv.resize(frame, dimensions, interpolation=cv.INTER_AREA)

    resized_image = rescaleFrame(img)
    cv.imshow('Resized detected images', resized_image)

    #printing number of plastic
    print(f'Number of plastic found = {len(plastic_1)}')

    #Checking plastic found or not
    if len(plastic_1):
        print("Plastic found")
    else:
        print("Plastic not found")

    cv.waitKey(0)

if __name__ == "__main__":
    plastic_detect()