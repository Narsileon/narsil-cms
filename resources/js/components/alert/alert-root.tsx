import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";
import alertRootVariants from "./alert-root-variants";

function AlertRoot({
  className,
  variant,
  ...props
}: ComponentProps<"div"> & VariantProps<typeof alertRootVariants>) {
  return (
    <div
      data-slot="alert-root"
      className={cn(
        alertRootVariants({
          className: className,
          variant: variant,
        }),
      )}
      role="alert"
      {...props}
    />
  );
}

export default AlertRoot;
