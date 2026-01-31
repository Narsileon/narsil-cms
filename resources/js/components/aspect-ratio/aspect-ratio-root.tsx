import { cn } from "@narsil-cms/lib/utils";
import { type CSSProperties, type ComponentProps } from "react";

type AspectRatioRootProps = ComponentProps<"div"> & { ratio: number };

function AspectRatioRoot({ className, ratio, ...props }: AspectRatioRootProps) {
  return (
    <div
      data-slot="aspect-ratio"
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

export default AspectRatioRoot;
