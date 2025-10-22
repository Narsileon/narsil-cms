function BackgroundPaper() {
  return (
    <div className="filter-[url(#paper)] absolute -z-10 h-full w-full top-0">
      <svg className="absolute" width="0" height="0">
        <filter id="paper" x="0%" y="0%" width="100%" height="100%" filterUnits="objectBoundingBox">
          <feTurbulence
            baseFrequency="0.02"
            numOctaves="4"
            result="noise"
            stitchTiles="stitch"
            type="fractalNoise"
          />
          <feDiffuseLighting in="noise" lightingColor="var(--color-binary)" surfaceScale="1.4">
            <feDistantLight azimuth="35" elevation="70" />
          </feDiffuseLighting>
        </filter>
      </svg>
    </div>
  );
}

export default BackgroundPaper;
