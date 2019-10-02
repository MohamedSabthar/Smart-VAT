#include <iostream>

using namespace std;

int max(int i, int j)
{
    return i > j ? i : j;
}

int lps(string word, int i, int j)
{
    if (i == j)
        return 1;
    if (word[i] == word[j] && i + 1 == j)
        return 2;
    if (word[i] == word[j])
        return lps(word, i + 1, j - 1) + 2;
    return max(lps(word, i, j - 1), lps(word, i + 1, j));
}

int main()
{
    string word;
    cin >> word;
    cout << lps(word, 0, word.length() - 1) << endl;

    return 0;
}