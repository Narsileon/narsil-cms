import { type ComponentProps } from "react";

import { cn } from "@narsil-cms/lib/utils";

type CardContentProps = ComponentProps<"div"> & {};

function CardContent({ className, ...props }: CardContentProps) {
  return (
    <div
      data-slot="card-content"
      className={cn("grid gap-y-4 p-4", className)}
      {...props}
    />
  );
}

export default CardContent;
