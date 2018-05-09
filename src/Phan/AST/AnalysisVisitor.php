<?php declare(strict_types=1);
namespace Phan\AST;

use Phan\AST\Visitor\KindVisitorImplementation;
use Phan\CodeBase;
use Phan\Issue;
use Phan\Language\Context;
use Phan\Language\FQSEN;
use Phan\Language\UnionType;
use Phan\Language\Type;
use Phan\Suggestion;

// TODO: Move to AST\Visitor?
abstract class AnalysisVisitor extends KindVisitorImplementation
{
    /**
     * @var CodeBase
     * The code base within which we're operating
     */
    protected $code_base;

    /**
     * @var Context
     * The context in which the node we're going to be looking
     * at exits.
     */
    protected $context;

    /**
     * @param CodeBase $code_base
     * The code base within which we're operating
     *
     * @param Context $context
     * The context of the parser at the node for which we'd
     * like to determine a type
     */
    public function __construct(
        CodeBase $code_base,
        Context $context
    ) {
        $this->context = $context;
        $this->code_base = $code_base;
    }

    /**
     * @param string $issue_type
     * The type of issue to emit such as Issue::ParentlessClass
     *
     * @param int $lineno
     * The line number where the issue was found
     *
     * @param int|string|FQSEN|UnionType|Type ...$parameters
     * Template parameters for the issue's error message
     *
     * @return void
     */
    protected function emitIssue(
        string $issue_type,
        int $lineno,
        ...$parameters
    ) {
        Issue::maybeEmitWithParameters(
            $this->code_base,
            $this->context,
            $issue_type,
            $lineno,
            $parameters
        );
    }

    /**
     * @param string $issue_type
     * The type of issue to emit such as Issue::ParentlessClass
     *
     * @param int $lineno
     * The line number where the issue was found
     *
     * @param array<int,int|string|FQSEN|UnionType|Type> $parameters
     * Template parameters for the issue's error message
     *
     * @param ?Suggestion $suggestion
     * A suggestion (may be null)
     *
     * @return void
     */
    protected function emitIssueWithSuggestion(
        string $issue_type,
        int $lineno,
        array $parameters,
        $suggestion
    ) {
        Issue::maybeEmitWithParameters(
            $this->code_base,
            $this->context,
            $issue_type,
            $lineno,
            $parameters,
            $suggestion
        );
    }
}
