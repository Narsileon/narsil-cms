import { Tooltip } from "@narsil-cms/blocks/tooltip";
import { ToggleRoot } from "@narsil-cms/components/toggle";
import { type ComponentProps } from "react";

type ToggleProps = ComponentProps<typeof ToggleRoot> & {
  tooltip?: string;
  tooltipProps?: ComponentProps<typeof Tooltip>;
};

function Toggle({ tooltip, tooltipProps, ...props }: ToggleProps) {
  const tooltipLabel = tooltip || tooltipProps?.tooltip;

  if (!tooltipLabel) {
    return <ToggleRoot {...props} />;
  }
  return (
    <Tooltip tooltip={tooltipLabel} {...tooltipProps}>
      <ToggleRoot aria-label={tooltipLabel as string} {...props} />
    </Tooltip>
  );
}

export default Toggle;
