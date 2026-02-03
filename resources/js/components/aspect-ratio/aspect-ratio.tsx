import { cn } from "@narsil-cms/lib/utils";
import { type CSSProperties, type ComponentProps } from "react";

type AspectRatioProps = ComponentProps<"div"> & { ratio: number };

function AspectRatio({ className, ratio, ...props }: AspectRatioProps) {
  return (
    <div
      data-slot="aspect"
      className={cn("relative", "aspect-(--ratio)", className)}
      style={
        {
          "--ratio": ratio,
        } as CSSProperties
      }
      {...props}
    />
  );
}

export default AspectRatio;
