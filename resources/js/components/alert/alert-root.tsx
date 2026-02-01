import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import { type ComponentProps } from "react";
import alertRootVariants from "./alert-root-variants";

type AlertRootProps = ComponentProps<"div"> & VariantProps<typeof alertRootVariants>;

function AlertRoot({ className, variant, ...props }: AlertRootProps) {
  return (
    <div
      data-slot="alert-root"
      role="alert"
      className={cn(
        alertRootVariants({
          className: className,
          variant: variant,
        }),
      )}
      {...props}
    />
  );
}

export default AlertRoot;
