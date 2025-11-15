import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type BackgroundPaperProps = ComponentProps<"svg">;

function BackgroundPaper({ className, id = "paper", ...props }: BackgroundPaperProps) {
  return (
    <svg data-slot="background-paper" className={cn("absolute size-0", className)} {...props}>
      <filter id={id} x="0%" y="0%" width="100%" height="100%" filterUnits="objectBoundingBox">
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
  );
}

export default BackgroundPaper;
