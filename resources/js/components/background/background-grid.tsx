import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type BackgroundGridProps = ComponentProps<"svg"> & {};

function BackgroundGrid({
  className,
  id = "grid",
  height = 16,
  width = 16,
  ...props
}: BackgroundGridProps) {
  return (
    <svg
      data-slot="background-grid"
      className={cn("pointer-events-none absolute inset-0 size-full bg-sidebar", className)}
      {...props}
    >
      <defs>
        <pattern id={id} width={width} height={height} patternUnits="userSpaceOnUse">
          <path
            className="stroke-border"
            d={`M ${width} 0 L 0 0 0 ${height}`}
            fill="none"
            strokeWidth="0.5"
          />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill={`url(#${id})`} mask="url(#fade-mask)" />
    </svg>
  );
}

export default BackgroundGrid;
