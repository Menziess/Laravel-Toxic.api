@extends('layouts.app')

@section('content')
@include('layouts.nav')

<div class="logo">
<!-- Stefan Schenk -->
</div>

<svg id="svg" class="svg" version="1.1" viewBox="0 0 400 400" style="opacity: 0.1;">
	<g id="svgg">
		<path id="path0" d="" stroke="none" fill="#00ff00" fill-rule="evenodd"></path>
		<path id="path1" d="M334.975 77.876 C 320.345 87.800,284.433 111.910,255.172 131.454 C 225.911 150.998,201.740 167.198,201.459 167.454 C 200.941 167.926,236.717 187.371,243.995 190.573 C 246.169 191.530,252.045 194.547,257.053 197.279 L 266.159 202.246 270.110 199.481 C 272.282 197.960,274.530 196.420,275.104 196.059 C 279.464 193.317,288.075 187.549,288.342 187.191 C 288.522 186.949,296.798 181.343,306.732 174.733 C 316.667 168.123,325.177 162.237,325.644 161.653 C 326.111 161.069,326.647 160.694,326.836 160.819 C 327.354 161.165,343.514 150.317,343.514 149.623 C 343.514 149.291,343.767 149.176,344.076 149.367 C 344.385 149.558,345.789 148.735,347.196 147.538 C 348.603 146.341,360.475 138.215,373.578 129.481 C 396.424 114.252,397.371 113.539,396.624 112.136 C 395.101 109.276,374.828 79.142,374.283 78.927 C 373.977 78.807,373.727 78.430,373.727 78.089 C 373.727 77.512,362.064 59.734,361.729 59.801 C 361.645 59.817,349.606 67.951,334.975 77.876 M20.033 87.162 C 10.279 101.794,2.217 113.981,2.116 114.244 C 1.893 114.831,26.288 131.100,27.045 130.870 C 27.343 130.780,27.586 130.986,27.586 131.327 C 27.586 131.669,28.291 132.334,29.153 132.805 C 30.015 133.276,32.511 134.918,34.700 136.453 C 36.889 137.989,38.956 139.245,39.292 139.245 C 39.629 139.245,40.298 139.719,40.779 140.298 C 41.260 140.878,42.261 141.583,43.004 141.865 C 43.747 142.148,49.306 145.664,55.358 149.679 C 61.411 153.694,66.628 156.979,66.952 156.979 C 67.277 156.979,67.641 157.228,67.761 157.533 C 67.978 158.083,97.556 177.997,98.156 177.997 C 98.327 177.997,106.238 183.168,115.736 189.489 C 132.703 200.780,133.008 200.949,133.200 199.150 C 133.404 197.240,197.977 168.082,199.677 169.133 C 200.035 169.354,200.328 169.106,200.328 168.582 C 200.328 168.057,199.898 167.463,199.371 167.261 C 198.844 167.059,187.444 159.638,174.037 150.770 C 160.629 141.902,149.532 134.647,149.375 134.647 C 149.219 134.647,124.339 118.151,94.086 97.990 C 63.833 77.828,38.785 61.158,38.424 60.946 C 38.062 60.733,29.787 72.530,20.033 87.162 " stroke="none" fill="#2baf43" fill-rule="evenodd"></path>
		<path id="path2" d="M306.404 96.938 L 304.433 98.631 306.568 97.218 C 307.742 96.441,308.703 95.678,308.703 95.522 C 308.703 95.030,308.425 95.201,306.404 96.938 M180.952 155.349 C 181.675 155.937,182.857 156.708,183.580 157.063 L 184.893 157.708 183.580 156.638 C 182.857 156.050,181.675 155.279,180.952 154.924 L 179.639 154.279 180.952 155.349 M200.458 168.676 C 200.387 169.149,200.035 169.354,199.677 169.133 C 199.318 168.911,184.225 175.175,166.136 183.051 L 133.247 197.373 133.455 262.069 C 133.569 297.652,133.745 334.988,133.846 345.039 L 134.031 363.312 161.761 363.101 C 177.012 362.985,192.225 362.795,195.567 362.679 L 201.642 362.468 201.548 315.717 C 201.454 268.742,200.700 167.070,200.458 168.676 M247.291 192.651 C 253.101 195.975,265.353 202.368,265.353 202.076 C 265.353 201.696,245.833 191.130,245.151 191.141 C 244.883 191.145,245.846 191.825,247.291 192.651 " stroke="none" fill="#2ec248" fill-rule="evenodd"></path>
		<path id="path3" d="M295.658 103.432 C 290.109 107.169,285.232 110.587,284.821 111.026 C 284.409 111.465,289.023 108.532,295.074 104.507 C 301.125 100.482,306.076 97.046,306.076 96.871 C 306.076 96.397,306.484 96.139,295.658 103.432 M98.851 100.939 C 99.847 101.983,109.555 108.374,110.144 108.374 C 110.427 108.374,108.741 107.094,106.397 105.528 C 100.609 101.663,98.064 100.116,98.851 100.939 M255.923 130.360 C 247.666 135.902,240.572 140.796,240.160 141.235 C 239.574 141.858,270.746 121.409,271.866 120.435 C 272.017 120.304,271.869 120.216,271.538 120.240 C 271.207 120.264,264.180 124.817,255.923 130.360 M142.203 129.607 C 154.921 138.084,157.579 139.773,156.650 138.791 C 155.672 137.756,132.128 122.167,131.543 122.167 C 131.267 122.167,136.064 125.515,142.203 129.607 M201.205 235.157 C 201.445 272.114,201.642 315.899,201.642 332.457 L 201.642 362.562 234.179 362.562 L 266.716 362.562 266.405 349.261 C 266.233 341.946,266.062 305.961,266.025 269.294 L 265.956 202.627 234.021 185.550 C 216.457 176.158,201.790 168.358,201.427 168.218 C 200.986 168.047,200.912 190.257,201.205 235.157 " stroke="none" fill="#30cf4f" fill-rule="evenodd"></path>
		<path id="path4" d="M72.767 6.351 C 71.919 7.735,70.938 9.340,70.588 9.918 C 70.237 10.496,68.887 12.565,67.586 14.516 C 63.205 21.085,53.202 36.839,53.202 37.168 C 53.202 37.347,52.908 37.851,52.550 38.287 C 50.919 40.271,37.934 60.481,38.165 60.677 C 39.003 61.392,58.478 74.220,58.726 74.220 C 58.891 74.220,75.313 85.008,95.220 98.194 C 115.127 111.379,131.553 122.167,131.722 122.167 C 131.891 122.167,147.473 132.466,166.350 145.054 L 200.670 167.941 209.202 162.128 C 236.416 143.586,289.777 107.587,322.989 85.364 C 344.031 71.284,361.248 59.493,361.248 59.161 C 361.248 58.829,360.555 57.722,359.708 56.701 C 358.860 55.679,355.194 50.386,351.560 44.938 C 347.927 39.489,344.535 34.612,344.023 34.100 C 343.511 33.588,338.864 26.814,333.697 19.048 C 328.530 11.281,324.078 4.679,323.803 4.377 C 323.528 4.075,315.692 8.952,306.390 15.215 C 297.088 21.477,288.704 27.100,287.760 27.710 C 286.815 28.320,285.661 29.156,285.194 29.568 C 284.728 29.980,266.706 42.013,245.147 56.308 C 223.587 70.604,205.580 82.625,205.131 83.022 C 204.682 83.419,203.931 84.039,203.463 84.401 C 202.994 84.762,202.130 85.435,201.544 85.897 C 200.626 86.620,195.433 83.396,164.259 62.744 C 144.338 49.549,127.874 38.752,127.671 38.752 C 127.468 38.752,126.516 38.157,125.555 37.429 C 122.837 35.369,76.121 4.530,75.162 4.162 C 74.671 3.973,73.656 4.901,72.767 6.351 " stroke="none" fill="#52ff77" fill-rule="evenodd"></path>
	</g>
</svg>

<div class="container">
	<div class="row">

		<div class="container">
			
			<!-- Hidden Modal -->
			<NewPost></NewPost>

			<!-- Post Manager -->
			<Manager json="{{ $posts }}"></Manager>

		</div>

	</div>
</div>
@endsection
