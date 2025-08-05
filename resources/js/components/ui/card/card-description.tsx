import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";

type CardDescriptionProps = React.ComponentProps<"div"> & {};

function CardDescription({ className, ...props }: CardDescriptionProps) {
  return (
    <div
      data-slot="card-description"
      className={cn("text-muted-foreground text-sm", className)}
      {...props}
    />
  );
}

export default CardDescription;
