$('#movie').mousedown(function(e){
		
	moveXdown = e.pageX;
	moveYdown = e.pageY;
	movieWidth = $('#movie').css('width').replace(/[^-\d\.]/g, '');
	movieHeight = $('#movie').css('height').replace(/[^-\d\.]/g, '');
	OnehalfWidth = movieWidth / 2;
    OnehalfHeight = movieHeight / 2;
	TwohalfHeight = movieHeight / 3;
	TwohalfWidth = movieWidth / 3;
	ThreehalfWidth = movieWidth / 4;
	ThreehalfHeight = movieHeight / 4;
	One_onehalfWidth = OnehalfWidth / 2;
	FourhalfWidth = movieHeight / 4;
	FourhalfHeight = movieHeight / 4;
	switch(mcuCompType)
	{
		case 0: console.log("화면 1"); break;
		case 1:
			if(moveXdown < OnehalfWidth && moveYdown < OnehalfHeight)
    		{
	    		num = 0;
    		}
    		else if(moveXdown > OnehalfWidth && moveYdown < OnehalfHeight)
			{
	    		num = 1;
    		}
    		else if(moveXdown < OnehalfWidth && moveYdown > OnehalfHeight)
			{
				num = 2;
    		}
  			else{
        		num = 3;
   			}
			break;
		case 2:	
			if(moveXdown < TwohalfWidth && moveYdown < TwohalfHeight)
			{
				num = 0;
			}
			else if(moveXdown < TwohalfWidth*2 && moveYdown < TwohalfHeight)
			{
				num = 1;
			}
			else if(moveXdown > TwohalfWidth*2 && moveYdown < TwohalfHeight)
			{	
				num = 2;
			}
			else if(moveXdown < TwohalfWidth && moveYdown < TwohalfHeight*2)
			{
				num = 3;
			}
			else if(moveXdown < TwohalfWidth*2 && moveYdown < TwohalfHeight*2)
			{
				num = 4;
			}
			else if(moveXdown > TwohalfWidth*2 && moveYdown < TwohalfHeight*2)
			{
				num = 5;
			}
			else if(moveXdown < TwohalfWidth && moveYdown > TwohalfHeight*2)
			{
				num = 6;
			}
			else if(moveXdown < TwohalfWidth*2 && moveYdown > TwohalfHeight*2)
			{
				num = 7;
			}
			else
			{
				num = 8;
			}
			break;
		case 9:
			if(moveXdown < ThreehalfWidth && moveYdown < ThreehalfHeight)
			{		
				num = 0;
			}
			else if(moveXdown > ThreehalfWidth && moveXdown < ThreehalfWidth*2 && moveYdown < ThreehalfHeight)
			{
				num = 1;
			}
			else if(moveXdown > ThreehalfWidth*2 && moveXdown < ThreehalfWidth*3 && moveYdown < ThreehalfHeight)
			{
				num = 2;
			}
			else if(moveXdown > ThreehalfWidth*3 && moveYdown < ThreehalfHeight)
	        {
			    num = 3;
		    }
			else if(moveXdown < ThreehalfWidth && moveYdown > ThreehalfHeight && moveYdown < ThreehalfHeight*2)
			{
				num = 4;
			}
			else if(moveXdown > ThreehalfWidth && moveXdown < ThreehalfWidth*2 && moveYdown > ThreehalfHeight && moveYdown < ThreehalfHeight*2)
		    {
			    num = 5;
			}
			else if(moveXdown > ThreehalfWidth*2 && moveXdown < ThreehalfWidth*3 && moveYdown > ThreehalfHeight && moveYdown < ThreehalfHeight*2)
			{
				num = 6;
			}
			else if(moveXdown > ThreehalfWidth*3 && moveYdown < ThreehalfHeight*2)
		    {
			    num = 7;
			}
			else if(moveXdown < ThreehalfWidth && moveYdown < ThreehalfHeight*3)
			{
				num = 8;
			}
			else if(moveXdown > ThreehalfWidth && moveXdown < ThreehalfWidth*2 && moveYdown < ThreehalfHeight*3)
			{
				num = 9;
			}
			else if(moveXdown > ThreehalfWidth*2 && moveXdown < ThreehalfWidth * 3 && moveYdown < ThreehalfHeight*3)
			{
				num = 10;
			}
			else if(moveXdown > ThreehalfWidth*3 && moveYdown < ThreehalfHeight*3)
			{
				num = 11;
			}
			else if(moveXdown < ThreehalfWidth && moveYdown > ThreehalfHeight*3)
			{
				num = 12;
			}
			else if(moveXdown > ThreehalfWidth && moveXdown < ThreehalfWidth*2 && moveYdown > ThreehalfHeight*3)
		    {
			    num = 13;
			}
			else if(moveXdown > ThreehalfWidth*2 && moveXdown < ThreehalfWidth*3 && moveYdown > ThreehalfHeight*3)
			{
				num = 14;
			}
			else
			{
				num = 15;
			}
			break;	
		case 22:
			if(moveXdown < OnehalfWidth+One_onehalfWidth)
			{
				num = 0;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown < TwohalfHeight)
			{
				num = 1;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown > TwohalfHeight && moveYdown < TwohalfHeight*2)
			{
				num = 2;
			}
			else{
				num = 3;
			}
			break;
		case 10:
			if(moveXdown < OnehalfWidth+One_onehalfWidth)
			{
				num = 0;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown < ThreehalfHeight)
			{
				num = 1;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown > ThreehalfHeight && moveYdown < ThreehalfHeight*2)
			{
				num = 2;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown > ThreehalfHeight*2 && moveYdown < ThreehalfHeight*3)
			{
				num = 3;
			}
			else
			{
				num = 4;
			}
			break;
		case 5:
			if(moveXdown < OnehalfWidth+One_onehalfWidth && moveYdown < TwohalfHeight*2)
			{
				num = 0;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown < TwohalfHeight)
			{
				num = 1;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown > TwohalfHeight && moveYdown < TwohalfHeight*2)
			{
				num = 2;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown > TwohalfHeight*2)
			{
				num = 5;
			}
			else if(moveXdown < OnehalfWidth-One_onehalfWidth && moveYdown > TwohalfHeight*2)
			{
				num = 3;
			}
			else
			{
				num = 4;
			}
			break;
		case 4:
			if(moveXdown < OnehalfWidth+One_onehalfWidth && moveYdown < ThreehalfHeight*3)
			{
				num = 0;
	        }
	        else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown < ThreehalfHeight)
	        {
				num = 1;
		    }
		    else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown > ThreehalfHeight && moveYdown < ThreehalfHeight*2)
		    {
		        num = 2;
		    }
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown > ThreehalfHeight*2 && moveYdown < ThreehalfHeight*3)
		    {
				num = 3;
		    }
			else if(moveXdown < OnehalfWidth-One_onehalfWidth && moveYdown > ThreehalfHeight*3)
			{
			  	num = 4;
			}
			else if(moveXdown > OnehalfWidth-One_onehalfWidth && moveXdown < OnehalfWidth && moveYdown > ThreehalfHeight*3)
			{
				num = 5;
			}
			else if(moveXdown > OnehalfWidth && moveXdown < OnehalfWidth+One_onehalfWidth && moveYdown > ThreehalfHeight*3)
			{
				num = 6;
			}
			else
			{
				num = 7;
			}
			break;
		case 3:
			if(moveXdown < OnehalfWidth && moveYdown < OnehalfHeight)
			{
				num = 0;
			}
			else if(moveXdown > OnehalfWidth && moveYdown < OnehalfHeight)
			{
				num = 1;
			}
			else if(moveXdown < OnehalfWidth && moveYdown > OnehalfHeight)
			{
				num = 2;
			}
			else if(moveXdown > OnehalfWidth && moveYdown > OnehalfHeight && moveXdown < OnehalfWidth+FourhalfWidth && moveYdown < OnehalfHeight+FourhalfHeight)
			{
				num = 3;
			}
			else if(moveXdown > OnehalfWidth && moveYdown > OnehalfHeight && moveXdown > OnehalfWidth+FourhalfWidth && moveYdown < OnehalfHeight+FourhalfHeight)
			{
				num = 4;
			}
			else if(moveXdown > OnehalfWidth && moveYdown > OnehalfHeight && moveXdown < OnehalfWidth+FourhalfWidth && moveYdown > OnehalfHeight+FourhalfHeight)
			{
				num = 5;
			}
			else
			{
				num = 6;
			}
			break;
		case 7:
			if(moveXdown < OnehalfWidth-One_onehalfWidth && moveYdown > ThreehalfHeight*3)
			{
				num = 1;
			}
			else
			{
				num = 0;
			}
		break;
		case 8:
			if(moveXdown < OnehalfWidth-One_onehalfWidth && moveYdown > ThreehalfHeight*3)
			{
				num = 1;
			}
			else if(moveXdown > OnehalfWidth+One_onehalfWidth && moveYdown > ThreehalfHeight*3)
			{
				num = 3;
			}
			else if(moveYdown < ThreehalfHeight*3)
			{
				num = 0;
			}
			else
			{
				num = 2;
			}
		break;

		}
	});