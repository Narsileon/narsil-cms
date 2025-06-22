export type SectionContentProps = React.ComponentProps<"div"> & {};

function SectionContent({ ...props }: SectionContentProps) {
  return <div data-slot="section-content" {...props} />;
}

export default SectionContent;
