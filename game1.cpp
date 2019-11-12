#include<bits/stdc++.h>

using namespace std;

int c=0,grid[9][9]={{0,6,0,4,0,0,7,1,0},
                    {0,0,0,0,2,7,0,9,0},
                    {0,0,8,1,0,5,0,0,0},
                    {0,0,0,0,0,1,9,0,0},
                    {0,8,5,3,0,2,1,4,0},
                    {0,0,3,9,0,0,0,0,0},
                    {0,0,0,7,0,6,2,0,0},
                    {0,4,0,2,9,0,0,0,0},
                    {0,2,9,0,0,3,0,8,0}};

bool is_in_row(int p,int x)
{
    int i;
    for(i=0;i<9;i++)
        if(grid[p][i]==x)
            return true;
    return false;
}

bool is_in_column(int p,int x)
{
    int i;
    for(i=0;i<9;i++)
        if(grid[i][p]==x)
            return true;
    return false;
}

bool is_in_box(int p,int x)
{
    int i,j;
    for(i=0;i<3;i++)
        for(j=0;j<3;j++)
            if(grid[((p/3)*3)+i][((p%3)*3)+j]==x)
                return true;
    return false;
}

void rows()
{
    int i,j,k;

    for(i=0;i<9;i++)
    {
        int x=0,y=0;
        for(j=0;j<9;j++)
        {
            if(grid[i][j]==0)
            {
                x++;
            }
            else
            {
                y+=grid[i][j];
            }
        }
        if(x==1)
        {
            for(j=0;j<9;j++)
            {
                if(grid[i][j]==0)
                {
                    grid[i][j]=45-y;
                    printf("r1: %d %d %d\n",i,j,45-y);
                    c++;
                    break;
                }
            }
        }
        else
        {

            for(j=1;j<=9;j++)
            {
                if(!is_in_row(i,j))
                {
                    x=0;
                    for(k=0;k<9;k++)
                    {
                        if(!is_in_column(k,j) && !is_in_box(((i/3)*3)+(k/3),j) && grid[i][k]==0)
                            x++;
                        if(x==2)
                            break;
                    }
                    if(x==1)
                    {
                        for(k=0;k<9;k++)
                        {
                            if(!is_in_column(k,j) && !is_in_box(((i/3)*3)+(k/3),j) && grid[i][k]==0)
                            {
                                grid[i][k]=j;
                                printf("r2: %d %d %d\n",i,k,j);
                                c++;
                                break;
                            }
                        }
                    }
                }
            }
        }
    }
}

void columns()
{
    int i,j,k;

    for(i=0;i<9;i++)
    {
        int x=0,y=0;
        for(j=0;j<9;j++)
        {
            if(grid[j][i]==0)
            {
                x++;
            }
            else
            {
                y+=grid[j][i];
            }
        }
        if(x==1)
        {
            for(j=0;j<9;j++)
            {
                if(grid[j][i]==0)
                {
                    grid[j][i]=45-y;
                    printf("c1: %d %d %d\n",j,i,45-y);
                    c++;
                    break;
                }
            }
        }
        else
        {
            for(j=1;j<=9;j++)
            {
                if(!is_in_column(i,j))
                {
                    x=0;
                    for(k=0;k<9;k++)
                    {
                        if(!is_in_row(k,j) && !is_in_box(((k/3)*3)+(i/3),j) && grid[k][i]==0)
                        {
                            x++;
                        }
                        if(x==2)
                            break;
                    }
                    if(x==1)
                    {
                        for(k=0;k<9;k++)
                        {
                            if(!is_in_row(k,j) && !is_in_box(((k/3)*3)+(i/3),j) && grid[k][i]==0)
                            {
                                grid[k][i]=j;
                                printf("c2: %d %d %d\n",k,i,j);
                                c++;
                                break;
                            }
                        }
                    }
                }
            }
        }
    }
}

void box()
{
    int i,j,k,l,x,y;

    for(i=0;i<9;i++)
    {
        x=y=0;
        for(j=0;j<3;j++)
        {
            for(k=0;k<3;k++)
            {
                if(grid[((i/3)*3)+j][((i%3)*3)+k]==0)
                    x++;
                else
                    y+=grid[((i/3)*3)+j][((i%3)*3)+k];
            }
        }
        if(x==1)
        {
            for(j=0;j<3 && x;j++)
            {
                for(k=0;k<3;k++)
                {
                    if(grid[((i/3)*3)+j][((i%3)*3)+k]==0)
                    {
                        grid[((i/3)*3)+j][((i%3)*3)+k]=45-y;
                        printf("b1: %d %d %d\n",((i/3)*3)+j,((i%3)*3)+k,45-y);
                        c++;
                        x--;
                        break;
                    }
                }
            }
        }
        else
        {
            for(j=1;j<=9;j++)
            {
                if(!is_in_box(i,j))
                {
                    x=0;
                    for(k=0;k<3;k++)
                    {
                        for(l=0;l<3;l++)
                        {
                            if(!is_in_column(((i%3)*3)+l,j) && !is_in_row(((i/3)*3)+k,j) && grid[((i/3)*3)+k][((i%3)*3)+l]==0)
                                x++;
                            if(x==2)
                                break;
                        }
                    }
                    if(x==1)
                    {
                        for(k=0;k<3 && x;k++)
                        {
                            for(l=0;l<3;l++)
                            {
                                if(!is_in_column(((i%3)*3)+l,j) && !is_in_row(((i/3)*3)+k,j) && grid[((i/3)*3)+k][((i%3)*3)+l]==0)
                                {
                                    grid[((i/3)*3)+k][((i%3)*3)+l]=j;
                                    printf("b2: %d %d %d\n",((i/3)*3)+k,((i%3)*3)+l,j);
                                    c++;
                                    x--;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

int main()
{
    int i,j,k,z=81;

    for(i=0;i<9;i++)
        for(j=0;j<9;j++)
            if(grid[i][j]!=0)
                c++;

    while(z--)
    {
        rows();
        columns();
        box();
        //mebreak;
    }

    for(i=0;i<9;i++)
    {
        for(j=0;j<9;j++)
        {
            printf("%d ",grid[i][j]);
        }
        printf("\n");
    }
}
